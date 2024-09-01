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

        <!-- Add To-do Form -->
        <form @submit.prevent="addTodo" class="todo-form mb-6">
            <input v-model="newTodo" type="text" placeholder="Add a new todo" class="todo-input" />
            <button type="submit" class="btn-add">Add</button>
        </form>

        <!-- To-do List -->
        <h3 class="text-red-600 text-xl mb-4">Pending Todos</h3>
        <ul class="todo-list">
            <li v-for="todo in pendingTodos" :key="todo.id" class="todo-item">
                <span>{{ todo.title }}</span>
                <div class="todo-buttons">
                    <button @click="completeTodo(todo)" class="btn-complete">Complete
                    </button>
                    <button @click="deleteTodo(todo.id)" class="btn-delete">Delete
                    </button>
                    <button @click="startEditing(todo)" class="btn-edit">Edit</button>
                </div>
            </li>
        </ul>

        <!-- Completed Todos -->
        <h3 class="text-green-600 text-xl mt-8 mb-4">Completed Todos</h3>
        <ul class="todo-list">
            <li v-for="todo in completedTodos" :key="todo.id" class="todo-item-complete completed">
                <span class="complete-text text-green-600">{{ todo.title }}</span>
                <div class="todo-buttons">
                    <button @click="deleteTodo(todo.id)" class="btn-delete">Delete
                    </button>
                </div>
            </li>
        </ul>

        <!-- Edit To-do Modal -->
        <div v-if="editingTodo"
             class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white p-4 rounded shadow-lg">
                <h3 class="text-xl font-bold mb-4">Edit Todo</h3>
                <input v-model="editingTodo.title" type="text"
                       class="border rounded py-2 px-4 mb-2"/>
                <button @click="updateTodo" class="btn-save">Save</button>
                <button @click="cancelEdit" class="btn-cancel">Cancel</button>
            </div>
        </div>
    </div>
</template>

<script>
import {ref, computed} from 'vue';
import {Inertia} from '@inertiajs/inertia';

export default {
    props: {
        todos: Array
    },
    setup(props) {
        const newTodo = ref('');
        const editingTodo = ref(null);

        const pendingTodos = computed(() => props.todos.filter(todo => !todo.completed));
        const completedTodos = computed(() => props.todos.filter(todo => todo.completed));

        const addTodo = () => {
            Inertia.post('/todos', {title: newTodo.value, completed: false});
            newTodo.value = '';
        };

        const completeTodo = (todo) => {
            Inertia.put(`/todos/${todo.id}`, {...todo, completed: true});
        };

        const deleteTodo = (id) => {
            Inertia.delete(`/todos/${id}`);
        };

        const startEditing = (todo) => {
            editingTodo.value = {...todo};
        };

        const updateTodo = () => {
            Inertia.put(`/todos/${editingTodo.value.id}`, editingTodo.value);
            editingTodo.value = null;
        };

        const cancelEdit = () => {
            editingTodo.value = null;
        };

        return {
            newTodo,
            addTodo,
            completeTodo,
            deleteTodo,
            startEditing,
            editingTodo,
            updateTodo,
            cancelEdit,
            pendingTodos,
            completedTodos
        };
    }
};
</script>
