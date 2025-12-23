import './bootstrap';

import { createApp } from 'vue';
import VirtualZooApp from './components/VirtualZooApp.vue';

const mountPoint = document.getElementById('virtual-zoo-app');

if (mountPoint) {
	createApp(VirtualZooApp).mount(mountPoint);
}
