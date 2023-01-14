<template>
    <nav class="navbar bg-success">
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
                        <a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Dropdown
                        </a>
                        <ul class="dropdown-menu">
                            <li><NuxtLink class="dropdown-item" to="/profile">Profile</NuxtLink></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
  </template>
