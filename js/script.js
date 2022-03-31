
'use strict';

const IP = '185.35.160.110:8101';
const ACCESS_KEY = '123';

const btn = document.querySelector('.content-control__btn');

fetch('/php/laurent.php?ip=' + IP, {
      method: 'get',
      headers: {
          'Accept': 'application/json, text/plain, */*',
          'Content-Type': 'application/json',
          'Authorization': 'Bearer ' + ACCESS_KEY
      }
    })
  .then(res => res.json())
  .then(data => console.log(data.out_table0));

btn.addEventListener('click', () => {
  fetch('/php/laurent.php?ip=' + IP + '&out=5&st=toggle', {
        method: 'get',
        headers: {
            'Accept': 'application/json, text/plain, */*',
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + ACCESS_KEY
        }
      })
    .then(res => res.text())
    .then(data => console.log(data))
});
