 <p>Dear {{ $giftCard->recipient_name }},</p>

 <p>Here are the details for your gift card:</p>

 <p>Gift Card Brand: {{ $giftCard->brand_name }}</p>

 <p>Gift Card Code: {{ $giftCard->value }}</p>
 <p>Amount: {{ $giftCard->price }} {{ $giftCard->currency }}</p>

 <p>Thank you for choosing our gift card!</p>
