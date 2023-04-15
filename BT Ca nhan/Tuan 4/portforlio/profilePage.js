

const subNav_link = document.querySelectorAll('.sub-nav li');
const subContent = document.querySelectorAll('.sub-profile__item ');
subNav_link.forEach((value, index) => {
    if(index == 0){
        value.addEventListener('click', () => {
            subContent[0].classList.add('showing');
            subNav_link[0].classList.add('showing');
            subNav_link[1].classList.remove('showing');
        })
    }
    else {
        value.addEventListener('click', () => {
            subNav_link[1].classList.add('showing');
            subNav_link[0].classList.remove('showing');
            subContent[0].classList.remove('showing');
        })
    }
   
})

const detailNavlink = document.querySelectorAll('.menu-wrapper__item');
const detailWrapper = document.querySelectorAll('.detail-profile__wrapper');

const resetOnShowing = () => {
    detailNavlink.forEach((value, index) => {
        value.classList.remove('showing');
        if(detailWrapper[index]){

            detailWrapper[index].classList.remove('showing');
        }

    })
}

detailNavlink.forEach((value, index ) => {

    value.addEventListener('click', () => {
        resetOnShowing();
        value.classList.add('showing');
        if(detailWrapper[index]){
        detailWrapper[index].classList.add('showing');
}})
})
const navMenu = document.querySelector('.menu-wrapper')
const directLeft = document.querySelector('.menu-direct-left');
const directRight = document.querySelector('.menu-direct-right');
let curStt = 0;
const statusMenuPos = [
    0, 92, 375
]

directLeft.addEventListener('click', ()=>{
    curStt--;
    if(curStt < 0){
        curStt = 0;
        return;
    };
    navMenu.style.transform = `translateX(${-statusMenuPos[curStt]}px)`;
   
})
directRight.addEventListener('click', ()=>{
   
    curStt++;
    if(curStt > 2) {
        curStt = 2;
        return;
    }
    navMenu.style.transform = `translateX(${-statusMenuPos[curStt]}px)`;
    
})
