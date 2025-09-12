import { getComponent, type Route, route } from './sources/generator';

import Home from '../pages/Home.svelte';
import User from '../pages/User.svelte';
import Install from '../pages/Install.svelte';
import Check from '../pages/Check.svelte';
import Login from '../pages/Login.svelte';
import LoadStudent from '../pages/admin/LoadStudent.svelte';
import DashboardContent from '../pages/admin/DashboardContent.svelte';
import Buttons from '../components/Nav/Buttons.svelte';
import CertificateButtons from '../components/Nav/CertificateButtons.svelte';
import History from '../pages/admin/History.svelte';
import Register from '../pages/admin/Register.svelte';
import Profile from '../pages/admin/Profile.svelte';
import Settings from '../pages/admin/Settings.svelte';

export const routes: Route[] = [
    route('/', getComponent(Home), []),
    route('/install/credentials', getComponent(Install), []),
    route('/credentials/check', getComponent(Check), []),
    route('/create/user', getComponent(User), []),
    route('/login', getComponent(Login), []),
    route('/dashboard', getComponent(DashboardContent), [], getComponent(Buttons)),
    route('/dashboard/certificate', getComponent(LoadStudent), [], getComponent(CertificateButtons)),
    route('/dashboard/history', getComponent(History), []),
    route('/dashboard/register', getComponent(Register), []),
    route('/dashboard/profile', getComponent(Profile), []),
    route('/dashboard/settings', getComponent(Settings), []),
];
