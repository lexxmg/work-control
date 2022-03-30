
'use strict';

const IP = '185.35.160.110:8101';

const btn = document.querySelector('.content-control__btn');

fetch('/php/laurent.php?ip=' + IP)
  .then(res => res.json())
  .then(data => console.log(data.out_table0));

btn.addEventListener('click', () => {
  fetch('/php/laurent.php?ip=' + IP + '&out=3&st=toggle')
    .then(res => res.text())
    .then(data => console.log(data))
});
