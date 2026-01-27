<!DOCTYPE html>
<html>
<head>
    <title>{{ $subjectLine }}</title>
</head>
<body>
    <p>Dear {{ $toName }},</p>

    <p>{!! nl2br(e($messageContent)) !!}</p>

    <p>Regards,<br>Team Leelija</p>
</body>
</html>
