export default defineNuxtRouteMiddleware(
    (to, from) =>
    {
        if(localStorage.getItem('accessToken'))
        {
            return navigateTo('/');
        }
    }
);