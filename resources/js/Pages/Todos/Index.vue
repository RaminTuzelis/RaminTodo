<template>
    <header class="nav-header">
        <div id="wrapper">
            <div class="logo">
                <img :src="`pen-svgrepo-com.svg`" alt="Logo">
                <p class="">RaminTodo</p>
            </div>
        </div>
    </header>


        <div class="hero-section">
            <h2 class="text-2xl font-bold">Your Todos</h2>
            <ul>
                <li v-for="todo in todos" :key="todo.id" class="text-lg">
                    {{ todo.title }}
                </li>
            </ul>
        </div>
</template>

<script>
export default {
    props: {
        todos: Array
    }
};
</script>
