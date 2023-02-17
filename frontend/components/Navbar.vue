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
                    <li class="nav-item">
                        <NuxtLink class="nav-link text-light" to="/cart">My Cart</NuxtLink>
                    </li>
                    <li class="nav-item dropdown">
                        <button class="btn text-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Profile</button>
                        <ul class="dropdown-menu">
                            <li><NuxtLink class="dropdown-item" to="/profile">Profile</NuxtLink></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <NuxtLink v-if="true" class="dropdown-item" to="/login">Login</NuxtLink>
                                <NuxtLink v-else class="dropdown-item" to="#">Logout</NuxtLink>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
  </template>
