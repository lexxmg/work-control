
'use strict';

const IP = '192.168.0.101'//'185.35.160.110:8101';
//const OUT_ARR = [1, 2, 3 , 5, 9];

if (window.location.pathname === '/') {
  const container = document.querySelector('.content-control');

  const OUT_ARR = container.dataset.out.split(',').map(item => {
    return item.trim();
  });

  const OUT_NAME = JSON.parse(container.dataset.outName);


  addBtnToContainer(container, OUT_ARR, OUT_NAME);
  isActive(IP, OUT_NAME);

  setInterval(() => {
    isActive(IP, OUT_NAME);
  }, 1000);

  container.addEventListener('click' , event => {
    const out = event.target.dataset.out;

    fetch(`/php/laurent.php?ip=${IP}&out=${out}&st=toggle`)
      .then(res => res.text())
      .then(data => {
        console.log(data);
        isActive(IP, OUT_NAME);
      })
  });
}

if (window.location.pathname === '/route/auth/') {
  const btn = document.querySelector('.auth__btn');
  const form = document.querySelector('.auth-form');

  btn.addEventListener('click', () => {
    form.reset();
    window.location.reload();
  });
}

if (window.location.pathname === '/route/admin/') {
  const container = document.querySelector('.admin-access-card-container');

  container.addEventListener('click', event => {
    const datasetBtn = event.target.dataset.btn;

    if (datasetBtn === 'btn' || datasetBtn === 'top' || datasetBtn === 'title') {
      const card = event.target.closest('.admin-access-card');
      const body = card.querySelector('.admin-access-card__body');
      const btn = card.querySelector('.admin-access-card-top-btn-container__btn');

      if (btn.ariaExpanded === 'true') {
        //body.classList.remove('admin-access-card__body--show');

        const bodyHeight = body.clientHeight;

        body.style.overflow = 'hidden';

        animate({
          duration: 400,
          timing(timeFraction) {
            return timeFraction;
          },
          draw(progress) {
            body.style.height = (bodyHeight - bodyHeight * progress) + 'px';
            if (progress === 1) {
              //console.log('end fbimation');
              body.style.display = 'none';
              body.style.height = '';
              body.style.overflow = '';
            }
          }
        });

        btn.classList.remove('admin-access-card-top-btn-container__btn--open');
        btn.ariaExpanded = 'false';
      } else {
        //body.classList.add('admin-access-card__body--show');

        body.style.position = 'absolute';
        body.style.visibility = 'hidden';
        body.style.display = 'block';

        const bodyHeight = body.clientHeight;

        body.style.overflow = 'hidden';
        body.style.height = 0;
        body.style.position = '';
        body.style.visibility = '';

        animate({
          duration: 400,
          timing(timeFraction) {
            return timeFraction;
          },
          draw(progress) {
            body.style.height = (bodyHeight * progress) + 'px';
            if (progress === 1) {
              //console.log('end fbimation');
              body.style.overflow = '';
            }
          }
        });
        

        btn.classList.add('admin-access-card-top-btn-container__btn--open');
        btn.ariaExpanded = 'true';
      }
    }
  });
}


function addBtnToContainer(container, outArr, outName) {
  if (outArr.length <= 1) {
    outArr.forEach((item, i) => {
      container.insertAdjacentHTML('beforeend' , `
        <div class="content-control__btn-container">
          <button class="content-control__btn btn-control" data-out="${item}"></button>

          <span class="content-control__text">${outName[item].name}</span>
        </div>
      `);
    });
  } else {
    container.classList.add('content-control--many');

    outArr.forEach((item, i) => {
      container.insertAdjacentHTML('beforeend' , `
        <div class="content-control__btn-container content-control__btn-container--many">
          <button class="content-control__btn btn-control" data-out="${item}"></button>

          <span class="content-control__text">${outName[item].name}</span>
        </div>
      `);
    });
  }
}

function isActive(ip, outName) {
  const allBtn = document.querySelectorAll('.content-control__btn');

  fetch(`/php/laurent.php?ip=${ip}`)
    .then(res => res.json())
    .then(data => {
      const outActive = data.out_table0.split('');

      outActive.forEach((item, i) => {
        allBtn.forEach((btn, j) => {
          if (i === btn.dataset.out - 1) {
            if (item == outName[i + 1].rev ? 0 : 1) {
              btn.classList.add('content-control__btn--active');
              btn.textContent = 'on';
            } else {
              btn.classList.remove('content-control__btn--active');
              btn.textContent = 'off';
            }
          }
        });
      });
    });
}

function animate({timing, draw, duration}) {

  let start = performance.now();

  requestAnimationFrame(function animate(time) {
    // timeFraction изменяется от 0 до 1
    let timeFraction = (time - start) / duration;
    if (timeFraction > 1) timeFraction = 1;

    // вычисление текущего состояния анимации
    let progress = timing(timeFraction);

    draw(progress); // отрисовать её

    if (timeFraction < 1) {
      requestAnimationFrame(animate);
    }

  });
}
