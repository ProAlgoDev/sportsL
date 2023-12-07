<!-- resources/views/email/emailVerificationEmail.blade.php -->
<!Doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Verification Email</title>
        <style>
                .email_logo {
                    text-align: center;
                }
                .email_title {
                    text-align: center;
                }
                .email_content {
                    text-align: center;
                }
                .email_content a{
                    display: block;
                    width: 140px;
                    background-color: #3FBAEE;
                    margin: auto;
                    margin-top: 30px;
                    border-radius: 10px;
                    padding: 12px;
                    color: white;
                    text-decoration: none;
                }
                .email_content a:hover{
                    background-color: #007fe7;
                }
                </style>
    </head>
    <body>
        
        <div class="email_body">
            <div class="email_logo">
                <img src='{{asset('images/next_log.png')}}' alt="" />
            </div>
            <div class="email_title">
                <h1>招待メール</h1>
            </div>
            <div class="email_content">
                <span>{{$teamName}}チームが招待メールを送信しました。<br>24時間以内に返信してください</span>
                <a href="{{route('validate_invite_mail',[$token])}}">訪問</a>
            </div>
        </div> 
    {{-- <a href="{{route('user.verify',$token)}}">Verify Email</a> --}}
    </body>

</div>
</html>