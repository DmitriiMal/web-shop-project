// ///////////////////////// //
// ////// Sweet Alert ////// //
// ///////////////////////// //

let okAlert = () => {
  Swal.fire({
    position: 'top-end',
    icon: 'success',
    title: 'Product added to cart',
    showConfirmButton: false,
    timer: 1500,
  });
};

// Forgotten password?
const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
const popoverList = [...popoverTriggerList].map((popoverTriggerEl) => new bootstrap.Popover(popoverTriggerEl));

// ////////////////////////// //
// ////// Cart buttons ////// //
// ////////////////////////// //

// let plus = document.querySelectorAll('.plus');
// let minus = document.querySelectorAll('.minus');
// let quantity = document.getElementsByClassName('quantity');

// const plusQtty = (index) => {
//   quantity[index].value++;
// };

//decreases item quantity
// plus.forEach((btn, i) => {
//   btn.addEventListener('click', () => {
//     plusQtty(i);
//   });
// });

// const plusQtty = (index) => {
//   quantity[index].value++;
// };

//decreases item quantity
// minus.forEach((btn, i) => {
//   btn.addEventListener('click', () => {
//     minusQtty(i);
//   });
// });

// const minusQtty = (index) => {
//   quantity[index].value--;
//   if (quantity[index].value < 0) {
//     quantity[index].value = 0;
//   }
// };

let priceCard = document.querySelectorAll('.price');
let navbarCart = document.querySelector('#total-quantity-navbar');

function updateTotalSum() {
  let xhttp = new XMLHttpRequest();
  xhttp.onload = function () {
    if (this.status === 200) {
      let response = JSON.parse(this.responseText);

      console.log(response);

      let totalSumElement = document.getElementById('sum');
      totalSumElement.innerHTML = `&euro; ${response[0].toFixed(2)}`;

      navbarCart.innerHTML = response[1];
    }
  };
  xhttp.open('GET', '/cart/get-total-sum', true);
  console.log('AJAX');
  xhttp.send();
}
updateTotalSum();

function displayPlus(e, id) {
  let xhttp = new XMLHttpRequest();
  xhttp.onload = function () {
    if (this.status == 200) {
      let respons = JSON.parse(this.responseText);
      console.log(respons);
      let qtty = JSON.parse(this.responseText)[0];
      let price = respons[1];
      let eachTotal = qtty * price;
      e.nextElementSibling.value = qtty;

      let totalPriceElement = e.closest('.row').querySelector('.price');
      totalPriceElement.innerHTML = `&euro; ${eachTotal.toFixed(2)}`;

      updateTotalQuantity(respons[2]);
      updateTotalSum(); // Call the function to update the total sum
    }
  };
  xhttp.open('GET', '/cart/plus/' + id, true);
  xhttp.send();
}

function displayMinus(e, id) {
  let xhttp = new XMLHttpRequest();
  xhttp.onload = function () {
    if (this.status == 200) {
      let respons = JSON.parse(this.responseText);
      let qtty = JSON.parse(this.responseText)[0];
      let price = respons[1];
      let eachTotal = qtty * price;
      e.previousElementSibling.value = qtty;

      let totalPriceElement = e.closest('.row').querySelector('.price');
      totalPriceElement.innerHTML = `&euro; ${eachTotal.toFixed(2)}`;

      updateTotalQuantity(respons[2]);
      updateTotalSum(); // Call the function to update the total sum
    }
  };
  xhttp.open('GET', '/cart/minus/' + id, true);
  xhttp.send();
}

function updateTotalQuantity(totalQuantity) {
  // Update the displayed total quantity
  document.getElementById('total-quantity').innerText = `Cart - ${totalQuantity} Item(s)`;
  // navbarCart.innerText = totalQuantity;
}

// /////////////////////////// //
// /////// Google Maps /////// //
// /////////////////////////// //

var map;

function initMap() {
  var CodeFactory = {
    lat: 48.19649124145508,
    lng: 16.35948371887207,
  };

  map = new google.maps.Map(document.getElementById('map'), {
    center: CodeFactory,
    zoom: 17,
  });

  console.log(map);

  var pinpoint = new google.maps.Marker({
    position: CodeFactory,
    map: map,
  });
}
