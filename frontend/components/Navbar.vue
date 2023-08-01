<template>
    <nav class="navbar fixed-top bg-success">
        <div class="container">
            <div>
                <nav class="nav text-light">
                    <NuxtLink class="navbar-brand text-light" to="/"><strong>eShop</strong></NuxtLink>
                    <a class="nav-link text-light" href="#">Search</a>
                </nav>
            </div>
            <!-- <div>
                <ul class="nav justify-content-center">
                    <li class="nav-item">
                        <a class="nav-link text-light" href="#">Link</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="#">Link</a>
                    </li>
                </ul>
            </div> -->
            <div>
                <ul class="nav justify-content-end">
                    <li class="nav-item" v-if="authUser?.is_admin">
                        <NuxtLink class="nav-link text-light" to="/store">My Store</NuxtLink>
                    </li>
                    <li class="nav-item" v-else>
                        <NuxtLink class="nav-link text-light" to="/cart">My Cart</NuxtLink>
                    </li>
                    <li class="nav-item dropdown" v-if="isAuth">
                        <button class="btn text-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Profile</button>
                        <ul class="dropdown-menu">
                            <li><NuxtLink class="dropdown-item" to="/profile">Profile</NuxtLink></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="" @click.prevent="logout()">Logout</a></li>
                        </ul>
                    </li>
                    <li class="nav-item" v-else>
                        <NuxtLink class="nav-link text-light" to="/login">Login</NuxtLink>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>
<script>
    export default
    {
        data()
        {
            let data =
            {
                isAuth: useIsAuthState(),
                authUser: useAuthUserState(),
            }

            return data;
        },

        mounted()
        {
            this.getIsAuth();
        },

        methods:
        {
            logout()
            {
                let url = useRuntimeConfig().public.API_URL + '/logout';
                let payload =
                {
                    method: "POST",
                    headers:
                    {
                        "Content-Type": "application/json",
                        'Authorization': 'Bearer ' + localStorage.getItem('accessToken'),
                    },
                };
                
                fetch(url, payload)
                .then((response) => response.json())
                .then((data) =>
                {
                    localStorage.removeItem('accessToken');
                    localStorage.removeItem('authUser');
                    this.getIsAuth();
                    this.$router.push('/login');
                })
                .catch((error) => { console.error("Error:", error); });
            },

            getIsAuth()
            {
                useIsAuthState().value = localStorage.getItem('accessToken') ? true : false;
                useAuthUserState().value = JSON.parse(localStorage.getItem('authUser')) ?? null;
            },
        }
    }
</script>