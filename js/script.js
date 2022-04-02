
'use strict';

const IP = '192.168.0.101'//'185.35.160.110:8101';
//const OUT_ARR = [1, 2, 3 , 5, 9];

if (window.location.pathname === '/') {
  const container = document.querySelector('.content-control');

  const OUT_ARR = container.dataset.out.split(',').map(item => {
    return item.trim();
  });

  const OUT_NAME = JSON.parse(container.dataset.outName);
  console.log(OUT_NAME[1]);

  addBtnToContainer(container, OUT_ARR, OUT_NAME);
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


function addBtnToContainer(container, outArr, outName) {
  if (outArr.length <= 1) {
    outArr.forEach((item, i) => {
      container.insertAdjacentHTML('beforeend' , `
        <div class="content-control__btn-container">
          <button class="content-control__btn btn-control" data-out="${item}">on/off</button>

          <span class="content-control__text">${outName[item]}</span>
        </div>
      `);
    });
  } else {
    container.classList.add('content-control--many');

    outArr.forEach((item, i) => {
      container.insertAdjacentHTML('beforeend' , `
        <div class="content-control__btn-container content-control__btn-container--many">
          <button class="content-control__btn btn-control" data-out="${item}">on/off</button>

          <span class="content-control__text">${outName[item]}</span>
        </div>
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
