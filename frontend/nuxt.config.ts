// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
    runtimeConfig:
    {
        public:
        {
            API_URL: process.env.API_URL || 'http://localhost:8000/api',
        }
    }
})
