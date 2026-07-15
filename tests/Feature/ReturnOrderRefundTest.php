<?php

namespace Tests\Feature;

use App\Http\Controllers\Admin\ReturnOrder;
use App\Models\Order;
use App\Models\Refund;
use App\Services\CashfreeRefundService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class ReturnOrderRefundTest extends TestCase
{
    use RefreshDatabase;

    public function test_processes_a_refund_for_a_return_order_using_the_admin_refund_endpoint(): void
    {
        $order = Order::create([
            'user_id' => 1,
            'total_amount' => 100.00,
            'order_status' => 'delivered',
            'payment_status' => 'paid',
            'payment_method' => 'cashfree',
            'cashfree_order_ref' => 'CF_TEST_1',
            'transection_id' => 'TXN123',
        ]);

        $service = \Mockery::mock(CashfreeRefundService::class);
        $service->shouldReceive('processPartialRefund')
            ->once()
            ->withArgs(function ($targetOrder, $amount, $reason, $speed) use ($order) {
                $this->assertSame($order->id, $targetOrder->id);
                $this->assertSame(50.0, $amount);
                $this->assertSame('Customer requested refund', $reason);
                $this->assertSame('STANDARD', $speed);

                return true;
            })
            ->andReturn([
                'refund_id' => 'REF-TEST-1',
                'cf_refund_id' => 'CF-REF-1',
                'refund_status' => 'SUCCESS',
                'refund_amount' => 50.0,
            ]);

        $this->app->instance(CashfreeRefundService::class, $service);

        $controller = app(ReturnOrder::class);
        $request = Request::create('/admin/return-orders/refund', 'POST', [
            'order_id' => $order->id,
            'amount' => 50.0,
            'reason' => 'Customer requested refund',
            'comments' => 'Testing refund flow',
        ]);

        $response = $controller->refund($request);

        $this->assertSame(200, $response->getStatusCode());
        $payload = $response->getData(true);
        $this->assertTrue($payload['success']);
        $this->assertSame(50.0, $payload['amount']);
        $this->assertTrue(Refund::where('order_id', $order->id)->exists());
    }
}
