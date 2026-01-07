<template>
    <div id="app">
        <nav class="navbar">
            <router-link to="/">Home</router-link>
        </nav>
        
        <main class="container">
            <router-view></router-view>
        </main>
    </div>
</template>

<script>
export default {
    name: 'App'
}
</script>

