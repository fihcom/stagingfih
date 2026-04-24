<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="https://eclickprojects.com/qeip-llc/assets/frontend/js/jquery.min.js"></script>
    <script src="https://cdn.plaid.com/link/v2/stable/link-initialize.js"></script>

    <title>Document</title>
</head>
<body>
    <script>
        $(function () {
                const linkHandler = Plaid.create({
                token: 'link-sandbox-fea4044b-ebdc-49ab-ae82-547519e3e526',
                onSuccess: (public_token, metadata) => {
                    // Send the public_token to your app server.
                    //console.log(metadata);
                    //console.log(public_token);
                    $.post('https://eclickprojects.com/qeip-llc/getaccesstoken', {
                    public_token: public_token,
                    },function(data){
                        console.log(data);
                    });
                },
                onExit: (err, metadata) => {
                    // Optionally capture when your user exited the Link flow.
                    // Storing this information can be helpful for support.
                },
                onEvent: (eventName, metadata) => {
                    // Optionally capture Link flow events, streamed through
                    // this callback as your users connect an Item to Plaid.
                },
                });
                linkHandler.open();
            
            
    });
        </script>
</body>
</html>