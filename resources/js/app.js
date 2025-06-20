import './bootstrap';
import { createApp } from 'vue';
import axios from 'axios';

const app = createApp({});
app.config.globalProperties.$axios = axios.create({
  baseURL: '/api',
  withCredentials: true
});
