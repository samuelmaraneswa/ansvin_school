import './bootstrap';
import './header/mainHeader'
import './auth/login'
import './toggleMenu&SubMenu'
import './sidebar'
import './auth/changePassword'
import './utility/toggleEye'

import { initFunctions } from './initFunctions';

document.addEventListener('DOMContentLoaded', () => {
  initFunctions()
})