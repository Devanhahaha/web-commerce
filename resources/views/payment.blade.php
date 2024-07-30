
<!DOCTYPE html>
<html>
<head>
    <title>Payment</title>
</head>
<body>
    <button id="pay-button">Pay!</button>
    
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result){
                    window.location.href = '/payment/success';
                },
                onPending: function(result){
                    console.log('pending');
                },
                onError: function(result){
                    console.log('error');
                },
                onClose: function(){
                    console.log('customer closed the popup without finishing the payment');
                }
            });
        });
    </script>
</body>
</html>
