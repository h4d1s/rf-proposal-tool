export {};
import Swiper from "swiper";
import { Navigation, Pagination } from 'swiper/modules';
import { SwiperOptions } from 'swiper/types';

const swiperParams: SwiperOptions = {
  modules: [Navigation, Pagination],
  slidesPerView: 3,
  spaceBetween: 30,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
};
const swiper = new Swiper(".swiper", swiperParams);
