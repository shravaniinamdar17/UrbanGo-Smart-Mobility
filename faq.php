<section class="faq-section">

<div class="container">

<div class="section-title">

<span>FREQUENTLY ASKED QUESTIONS</span>

<h2>Got Questions? We've Got Answers.</h2>

<p>

Everything you need to know about UrbanGo.

</p>

</div>

<div class="faq-container">

<div class="faq-item">

<button class="faq-question">

How do I book a ticket?

<i class="fa-solid fa-plus"></i>

</button>

<div class="faq-answer">

<p>

Choose your transport, select departure and destination, choose seats, pay securely and receive an instant QR ticket.

</p>

</div>

</div>

<div class="faq-item">

<button class="faq-question">

Can I cancel my booking?

<i class="fa-solid fa-plus"></i>

</button>

<div class="faq-answer">

<p>

Yes. Cancellation depends on the operator's policy. Refunds are processed directly to your original payment method.

</p>

</div>

</div>

<div class="faq-item">

<button class="faq-question">

Does UrbanGo provide Live Tracking?

<i class="fa-solid fa-plus"></i>

</button>

<div class="faq-answer">

<p>

Yes. Supported buses, cabs and other vehicles can be tracked live directly from your dashboard.

</p>

</div>

</div>

<div class="faq-item">

<button class="faq-question">

Which payment methods are accepted?

<i class="fa-solid fa-plus"></i>

</button>

<div class="faq-answer">

<p>

UPI, Debit Card, Credit Card, Net Banking, Wallets and Razorpay supported payment methods.

</p>

</div>

</div>

<div class="faq-item">

<button class="faq-question">

Does UrbanGo have an AI Assistant?

<i class="fa-solid fa-plus"></i>

</button>

<div class="faq-answer">

<p>

Yes. The AI Assistant helps you find routes, estimate fares, answer travel questions and recommend better travel options.

</p>

</div>

</div>

</div>

</div>

</section>

<script>

document.querySelectorAll(".faq-question").forEach(button=>{

button.onclick=function(){

const answer=this.nextElementSibling;

document.querySelectorAll(".faq-answer").forEach(item=>{

if(item!==answer){

item.style.maxHeight=null;

}

});

if(answer.style.maxHeight){

answer.style.maxHeight=null;

}else{

answer.style.maxHeight=answer.scrollHeight+"px";

}

};

});

</script>