require('./bootstrap');

import { createApp } from 'vue';
import deal from './components/deal';

createApp({
	components:{ deal }
}).mount('#productDetail');