// ////////////////////////// //
// ////////// Cart ////////// //
// ////////////////////////// //

let priceCard = document.querySelectorAll('.price');
let totalSumElement = document.getElementById('sum');
let serviceElement = document.getElementById('service');
let discountElement = document.getElementById('discount');
let totalElement = document.getElementById('total');
let totalQuantity = document.getElementById('total-quantity');

function updateTotalSum() {
  let xhttp = new XMLHttpRequest();
  xhttp.onload = function () {
    if (this.status === 200) {
      let response = JSON.parse(this.responseText);
      let totalQtty = response[1];
      let sum = response[0];
      let service = 4;
      let totalSum = sum + service;
      let discount = 10;
      if (sum >= 100) {
        totalSum = sum - (sum * discount) / 100 + service;
        discountElement.innerHTML = `${discount} %`;
        document.getElementById('discount-tytle').innerHTML = 'Discount';
        document.getElementById('order-over').innerHTML = '';
        totalQuantity.innerHTML = `Cart - ${totalQtty} Item(s)`;
      } else {
        document.getElementById('order-over').innerHTML = `Order over &euro;100 and get your discount`;
        discountElement.innerHTML = '';
        document.getElementById('discount-tytle').innerHTML = '';
        totalQuantity.innerHTML = `Cart - ${totalQtty} Item(s)`;
      }
      totalSumElement.innerHTML = `&euro; ${sum.toFixed(2)}`;
      serviceElement.innerHTML = `&euro; ${service}`;
      totalElement.innerHTML = `&euro; ${totalSum.toFixed(2)}`;
      totalQuantity.innerHTML = `Cart - ${totalQtty} Item(s)`;
    }
  };
  xhttp.open('GET', '/cart/get-total-sum', true);
  xhttp.send();
}
updateTotalSum();

function displayPlus(e, id) {
  let xhttp = new XMLHttpRequest();
  xhttp.onload = function () {
    if (this.status == 200) {
      let respons = JSON.parse(this.responseText);
      let qtty = JSON.parse(this.responseText)[0];
      let price = respons[1];
      let eachTotal = qtty * price;
      e.nextElementSibling.value = qtty;

      let totalPriceElement = e.closest('.row').querySelector('.price');
      totalPriceElement.innerHTML = `&euro; ${eachTotal.toFixed(2)}`;

      // updateTotalQuantity(respons[2]);
      updateTotalSum(); // Call the function to update the total sum
      updateNavQtty();
    }
  };
  xhttp.open('GET', '/cart/plus/' + id, true);
  xhttp.send();
}

function displayMinus(e, id) {
  let xhttp = new XMLHttpRequest();
  xhttp.onload = function () {
    if (this.status == 200) {
      // Reload the page when qtty = 0
      // console.log(this.responseText[0].charAt(0) == '[');
      if (this.responseText[0].charAt(0) !== '[') {
        window.location.reload();
      }
      let respons = JSON.parse(this.responseText);
      let qtty = JSON.parse(this.responseText)[0];
      let price = respons[1];
      let eachTotal = qtty * price;
      e.previousElementSibling.value = qtty;

      let totalPriceElement = e.closest('.row').querySelector('.price');
      totalPriceElement.innerHTML = `&euro; ${eachTotal.toFixed(2)}`;

      // updateTotalQuantity(respons[2]);
      updateTotalSum(); // Call the function to update the total sum
      updateNavQtty();
      if (qtty === 0) {
        // location.reload();
        window.location.reload();
      }
    } else {
      window.location.reload();
    }
  };
  xhttp.open('GET', '/cart/minus/' + id, true);
  xhttp.send();
}

// function updateTotalQuantity(totalQuantity) {
//   // Update the displayed total quantity
//   document.getElementById('total-quantity').innerText = `Cart - ${totalQuantity} Item(s)`;
// }
