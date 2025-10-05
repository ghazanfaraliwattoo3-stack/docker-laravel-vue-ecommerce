<template>
    <swiper
        :slidesPerView="1"
        :spaceBetween="30"
        :loop="true"
        :pagination="{
            clickable: true,
        }"
        :autoplay="{
            delay: 2500,
            disableOnInteraction: true,
        }"
        
        :modules="modules"
        class="mySwiperHero"
    >
        <swiper-slide>
            <div
                class="slide"
                style="
                    background: url('/frontend/banner-1.jpg') no-repeat
                        center/cover;
                "
            ></div>
        </swiper-slide>
        <swiper-slide>
            <div
                class="slide"
                style="
                    background: url('/frontend/banner-2.jpg') no-repeat
                        center/cover;
                "
            ></div>
        </swiper-slide>
    </swiper>
</template>

<script>
// Import Swiper Vue.js components
import { Swiper, SwiperSlide } from "swiper/vue";

// Import Swiper styles
import "swiper/css";
import "swiper/css/pagination";
// import 'swiper/css/navigation';

// Import required modules
import { Pagination, Autoplay } from "swiper/modules";

export default {
    name: "Hero",
    components: {
        Swiper,
        SwiperSlide,
    },
    data() {
        return {
            modules: [Pagination, Autoplay],
        };
    },
};
</script>

<style scoped>
/* Swiper container */
.mySwiperHero {
    width: 100%;
    height: 650px;
}

/* Background image div */
.slide {
    width: 100%;
    height: 100%;
}
@media (min-width: 200px) and (max-width: 768px) {
    .mySwiperHero {
        height: 400px;
    }
}
</style>
