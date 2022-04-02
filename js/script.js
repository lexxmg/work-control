
'use strict';

const IP = '192.168.0.101'//'185.35.160.110:8101';
const OUT_ARR = [1, 2, 3 , 5, 9];

if (window.location.pathname === '/') {
  const container = document.querySelector('.content-control');

  addBtnToContainer(container, OUT_ARR);
  isActive(IP);

  setInterval(() => {
    isActive(IP);
  }, 1000);

  container.addEventListener('click' , event => {
    const out = event.target.dataset.out;

    fetch(`/php/laurent.php?ip=${IP}&out=${out}&st=toggle`)
      .then(res => res.text())
      .then(data => {
        console.log(data);
        isActive(IP);
      })
  });
}

if (window.location.pathname === '/route/auth/') {
  const btn = document.querySelector('.auth__btn');

  btn.addEventListener('click', () => {
    window.location.reload();
  });
}


function addBtnToContainer(container, outArr) {
  if (outArr.length <= 1) {
    outArr.forEach((item, i) => {
      container.insertAdjacentHTML('beforeend' , `
        <button class="content-control__btn btn-control" data-out="${item}">on/off out-${item}</button>
      `);
    });
  } else {
    container.classList.add('content-control--many');

    outArr.forEach((item, i) => {
      container.insertAdjacentHTML('beforeend' , `
        <button class="content-control__btn btn-control content-control__btn--many" data-out="${item}">on/off out-${item}</button>
      `);
    });
  }
}

function isActive(ip) {
  const allBtn = document.querySelectorAll('.content-control__btn');

  fetch(`/php/laurent.php?ip=${ip}`)
    .then(res => res.json())
    .then(data => {
      const outActive = data.out_table0.split('');

      outActive.forEach((item, i) => {
        allBtn.forEach((btn, j) => {
          if (i === btn.dataset.out - 1) {
            if (item == 1) {
              btn.classList.add('content-control__btn--active');
            } else {
              btn.classList.remove('content-control__btn--active');
            }
          }
        });
      });
    });
}
