var phone = document.getElementById('phone');
var laptop = document.getElementById('laptop');
var keyboard = document.getElementById('keyboard');
var mouse = document.getElementById('mouse');
var airpods = document.getElementById('airpods');
var section1 = document.getElementById('section1');
var section2 = document.getElementById('section2');
var section3 = document.getElementById('section3');
var section4 = document.getElementById('section4');
var section5 = document.getElementById('section5');


// JavaScript to scroll to the second section
phone.addEventListener('click', function() {
    section1.scrollIntoView({ behavior: 'smooth' });
});

laptop.addEventListener('click', function() {
    section2.scrollIntoView({ behavior: 'smooth' });
});

keyboard.addEventListener('click', function() {
    section3.scrollIntoView({ behavior: 'smooth' });
});

mouse.addEventListener('click', function() {
    section4.scrollIntoView({ behavior: 'smooth' });
});

airpods.addEventListener('click', function() {
    section5.scrollIntoView({ behavior: 'smooth' });
});