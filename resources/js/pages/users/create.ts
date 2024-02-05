export {};
import { createApp } from 'vue';
import ImageUpload from '../../components/ImageUpload.vue';

const app = createApp({});
app.component('image-upload', ImageUpload);
app.mount('#image-upload');
