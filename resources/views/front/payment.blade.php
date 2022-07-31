<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        .payment-btn{
            padding: 50px;
            background-color: rgb(142, 226, 120);
        }
        .submit-btn {
            padding: 5px;
            background-color: olive;
            margin-top: 20px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    {{-- <a href="https://sandbox.nowpayments.io/donation?api_key=252193P-BM3402N-PMA5S4W-6K343AM" target="_blank">
        <img src="https://sandbox.nowpayments.io/images/embeds/donation-button-black.svg"
            alt="Crypto donation button by NOWPayments">
    </a>


    <a href="https://sandbox.nowpayments.io/payment/?iid=5104021951" target="_blank">
        <img src="https://sandbox.nowpayments.io/images/embeds/payment-button-black.svg"
            alt="Crypto donation button by NOWPayments">
    </a> --}}

    <form action="{{url('pay_now')}}" method="post">
        @csrf
        <input class="payment-btn" type="button" value="Total Bill: $100" readonly>
        <br>
        <input class="submit-btn" type="submit" value="Pay Now">
    </form>

</body>

</html>