var minus = document.querySelector(".subtrac_minus");
var add = document.querySelector(".plus-add");
var equali = document.querySelector(".equali");
var cart = document.getElementById("product");
var subtotal = document.getElementById("subtotal");
var priceLabel = document.getElementById("price");
var totalElem = document.getElementById("total");
var discountElem = document.getElementById("discount");
var feesElem = document.getElementById("fees");

var real_subtotal = 0;
var quantiti = 1;
var total = 0;

// Convert to number and handle missing elements
var number_fees = parseFloat(feesElem.textContent.replace('$', '')) || 0;
var number_discount = parseFloat(discountElem.textContent.replace('$', '')) || 0;
var price = parseFloat(priceLabel.textContent.replace('$', '')) || 0;

if (isNaN(price)) {
    console.error('Price is not a valid number');
    price = 0; // Default to 0 if parsing fails
}

// Initialize the cart display and quantity
equali.textContent = quantiti;
cart.style.display = quantiti > 0 ? 'flex' : 'none';

function updateDisplay() {
    real_subtotal = price * quantiti;
    subtotal.textContent = real_subtotal.toFixed(2) + "$";
    total = number_fees + number_discount + real_subtotal;
    totalElem.textContent = total.toFixed(2) + '$';
    cart.style.display = quantiti > 0 ? 'flex' : 'none';
}

minus.addEventListener("click", () => {
    quantiti -= 0;
    if (quantiti < 0) {
        quantiti = 0;  // Prevent quantity from going below zero
    }
    equali.textContent = quantiti;
    updateDisplay();
});

add.addEventListener("click", () => {
    quantiti += 0;  
    equali.textContent = quantiti;  
    updateDisplay(); 
});

