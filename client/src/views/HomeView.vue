<script setup>
import BaseHeader from "../components/BaseHeader.vue";
import BaseCalander from "../components/BaseCalander.vue";
import BaseCard from "../components/BaseCard.vue";
import BaseFooter from "../components/BaseFooter.vue";
import BaseCover from "../components/BaseCover.vue";
import {useTaskStore} from "../stores/TaskStore";
import { ref } from "vue";

const taskStore = useTaskStore();






// const imgCover = 'https://images.unsplash.com/photo-1600948836101-f9ffda59d250?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1136&q=80';
const cardsData = [
  {
    src: "https://singaporeblackmenbarber.files.wordpress.com/2016/08/14034957_656163167870044_5469974307300040624_n.jpg",
    content:
      " Fades are like whispers of the past, gently disappearing into the unknown, leaving traces of memories that linger in our hearts.",
  },
  {
    src: "https://images.unsplash.com/photo-1532710093739-9470acff878f?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1yZWxhdGVkfDJ8fHxlbnwwfHx8fA%3D%3D&auto=format&fit=crop&w=500&q=60",
    content:
      " The beard of a man is much more than just a physical attribute, it's a symbol of masculinity, wisdom, and character, evoking the heritage of the past and the pride of the present.",
  },
  {
    src: "https://i0.wp.com/therighthairstyles.com/wp-content/uploads/2014/05/6-360-waves-for-skin-fade.jpg?resize=500%2C500&ssl=1",
    content:
      " Men's haircuts are more than just styles, they're expressions of personality, confidence, and individuality, shaping a man's image and reflecting his unique story.",
  },
];


</script>

<template>
  <div class="home">
    <BaseHeader />
    <div class="cover">
      <h1>Always Best Fades</h1>
    </div><br><br>
    <h1 style="text-align: center; font-size: xx-large;">Some Happy clients </h1><br><br>
    <div class="cards">
      <BaseCard v-for="card in cardsData" :card="card" :key="card.content"/>
    </div>
  </div>
</template>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap");
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Roboto", sans-serif;
}

.cards {
  width: 90%;
  height: 120%;
  margin: auto;
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 40px;
  justify-content: center;
  justify-items: center;
}
.main-section {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  padding: 2rem;
  gap: 1rem;
}
.cover {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  height: 90vh;
  background-color: #333;
  background-image: url("https://www.salonsdirect.com/blog/wp-content/uploads/2020/11/What-Do-You-Need-to-Create-the-Sharpest-Skin-Fade.jpg") ;
  background-size: cover;
  color: #fff;
}

.cover h1 {
  font-size: 5rem;
  margin: 0;
}

.cover p {
  font-size: 2rem;
  margin: 0;
  background: gold;
  padding: 0.5rem;
  color: #333;
  transition: all 0.3s ease-in-out;
  cursor: pointer;
}

.cover p:hover {
  background: #333;
  color: gold;
  transform: rotate(10deg);
}

.cover a {
  text-decoration: none;
  color: #fff;
  padding: 0.5rem;
  margin-top: 1rem;
  background: #333;
  transition: all 0.3s ease-in-out;
  box-shadow: -1px -1px 5px -1px rgba(0, 0, 0, 0.27);
  -webkit-box-shadow: -1px -1px 5px -1px rgba(0, 0, 0, 0.27);
  -moz-box-shadow: -1px -1px 5px -1px rgba(0, 0, 0, 0.27);
}
.cover a:hover {
  background: rgb(0, 166, 255);
  color: #333;
  transform: scale(1.1);
}
</style>
