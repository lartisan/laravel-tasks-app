<template>
    <div class="tasks">
        <table class="table-auto w-full">
            <thead class="">
                <tr>
                    <!-- Completed -->
                    <th class="border-b px-4 py-3 text-center"></th>

                    <!-- Title -->
                    <th class="border-b px-4 py-3 text-left">
                        <a href="#" @click.prevent="handleOrder('title')" class="flex justify-between items-center focus:border-transparent focus:outline-none">
                            Task
                            <svg class="h-3 fill-current text-gray-600" viewBox="0 0 20 20">
                                <path v-if="filter === 'title' && order === 'asc'" d="M10 19.25L4.5 14H8V1h4v13h3.5L10 19.25z"/>
                                <path v-if="filter === 'title' && order === 'desc'" d="M10 .75L15.5 6H12v13H8V6H4.5L10 .75z"/>
                            </svg>
                        </a>
                    </th>

                    <!-- Assigned To -->
                    <th class="border-b px-4 py-3">
                        <a href="#" @click.prevent="handleOrder('assigned_to')" class="flex justify-between items-center focus:border-transparent focus:outline-none">
                            <span>Assigned To</span>
                            <svg class="h-3 fill-current text-gray-600" viewBox="0 0 20 20">
                                <path v-if="filter === 'assigned_to' && order === 'asc'" d="M10 19.25L4.5 14H8V1h4v13h3.5L10 19.25z"/>
                                <path v-if="filter === 'assigned_to' && order === 'desc'" d="M10 .75L15.5 6H12v13H8V6H4.5L10 .75z"/>
                            </svg>
                        </a>
                    </th>

                    <!-- Priority -->
                    <th class="border-b px-4 py-3">
                        <a href="#" @click.prevent="handleOrder('priority')" class="flex justify-between items-center focus:border-transparent focus:outline-none">
                            <span>Priority</span>
                            <svg class="h-3 fill-current text-gray-600" viewBox="0 0 20 20">
                                <path v-if="filter === 'priority' && order === 'asc'" d="M10 19.25L4.5 14H8V1h4v13h3.5L10 19.25z"/>
                                <path v-if="filter === 'priority' && order === 'desc'" d="M10 .75L15.5 6H12v13H8V6H4.5L10 .75z"/>
                            </svg>
                        </a>
                    </th>

                    <!-- Due Date -->
                    <th class="border-b px-4 py-3">
                        <a href="#" @click.prevent="handleOrder('due_date')" class="flex justify-between items-center focus:border-transparent focus:outline-none">
                            <span>Due Date</span>
                            <svg class="h-3 fill-current text-gray-600" viewBox="0 0 20 20">
                                <path v-if="filter === 'due_date' && order === 'asc'" d="M10 19.25L4.5 14H8V1h4v13h3.5L10 19.25z"/>
                                <path v-if="filter === 'due_date' && order === 'desc'" d="M10 .75L15.5 6H12v13H8V6H4.5L10 .75z"/>
                            </svg>
                        </a>
                    </th>

                    <!-- Actions -->
                    <th class="border-b px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="text-xs">
                <tr
                    v-for="(task, key) in tasks"
                    :key="key"
                    class="hover:bg-gray-200"
                >
                    <td class="border-b px-4 py-3">
                        <button
                            @click="toggleCompleted(task)"
                            class="focus:outline-none focus:border-transparent"
                        >
                            <svg class="h-5 fill-current" viewBox="0 0 32 32">
                                <path class="text-green-600" v-if="task.completed" d="M4 4v24h24V12.187l-2 2V26H6V6h19.813l2-2zm23.281 3.281L16 18.563l-4.281-4.282-1.438 1.438 5 5 .719.687.719-.687 12-12z"/>
                                <path class="text-gray-500" v-if="!task.completed" d="M6 6v20h20V6zm2 2h16v16H8z"/>
                            </svg>
                        </button>
                    </td>
                    <td :class="{ 'line-through text-gray-400': task.completed }" class="border-b px-4 py-3">{{ task.title }}</td>
                    <td :class="{ 'line-through text-gray-400': task.completed }" class="border-b px-4 py-3">{{ task.assigneeId === currentUser.id ? 'Me' : task.assignee }}</td>
                    <td :class="{ 'line-through text-gray-400': task.completed }" class="border-b px-4 py-3">
                        <span :class="badgeClass(task)" class="text-white text-xs ml-2 px-2 rounded-full">{{ task.priority }}</span>
                    </td>
                    <td :class="{ 'line-through text-gray-400': task.completed }" class="border-b px-4 py-3">{{ task.dueDate }}</td>
                    <td class="border-b px-4 py-3">
                        <button
                            @click="deleteTask(task)"
                            class="focus:outline-none focus:border-transparent text-gray-400 hover:text-red-600"
                        >
                            <svg class="h-4 fill-current" viewBox="0 0 92 92"><path d="M78.4 30.4l-3.1 57.8c-.1 2.1-1.9 3.8-4 3.8H20.7c-2.1 0-3.9-1.7-4-3.8l-3.1-57.8c-.1-2.2 1.6-4.1 3.8-4.2 2.2-.1 4.1 1.6 4.2 3.8l2.9 54h43.1l2.9-54c.1-2.2 2-3.9 4.2-3.8 2.1.1 3.8 2 3.7 4.2zM89 17c0 2.2-1.8 4-4 4H7c-2.2 0-4-1.8-4-4s1.8-4 4-4h22V4c0-1.9 1.3-3 3.2-3h27.6C61.7 1 63 2.1 63 4v9h22c2.2 0 4 1.8 4 4zm-53-4h20V8H36v5zm1.7 65c2 0 3.5-1.9 3.5-3.8l-1-43.2c0-1.9-1.6-3.5-3.6-3.5-1.9 0-3.5 1.6-3.4 3.6l1 43.3c0 1.9 1.6 3.6 3.5 3.6zm16.5 0c1.9 0 3.5-1.6 3.5-3.5l1-43.2c0-1.9-1.5-3.6-3.4-3.6-2 0-3.5 1.5-3.6 3.4l-1 43.2c-.1 2 1.5 3.7 3.5 3.7-.1 0-.1 0 0 0z"/></svg>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import axios from 'axios'
export default {
    name: "TasksCreatedByMe",
    props: ['currentUser'],
    data() {
        return {
            tasks: [],
            filter: 'due_date',
            order: 'desc'
        }
    },
    mounted() {
        this.getTasks();
    },
    methods: {
        getTasks() {
            return axios.get('/sanctum/csrf-cookie').then(resp => {
                axios.get(`/api/tasks?filter=${this.filter}&order=${this.order}`, {withCredentials: true}).then(resp => {
                    this.tasks = resp.data.data.filter(task => {
                            return task.ownerId === this.currentUser.id;
                        }
                    )
                    this.$emit('tasks-count', this.tasks.length)
                }).catch(err => {
                    console.log(err)
                })
            })
        },
        badgeClass(task) {
            if(task.completed === true) {
                return 'bg-gray-400';
            } else {
                switch (task.priority) {
                    case 'critical':
                        return 'bg-red-600';
                        break;
                    case 'high':
                        return 'bg-orange-400';
                        break;
                    case 'medium':
                        return 'bg-yellow-500';
                        break;
                    case 'low':
                        return 'bg-blue-400';
                        break;
                }
            }
        },
        toggleCompleted(task) {
            let data = {
                completed: !task.completed,
                withCredentials: true
            }

            axios.get('/sanctum/csrf-cookie').then(resp => {
                axios.put(`/api/tasks/${task.id}`, data).then(resp => {
                    this.getTasks();
                })
            })
        },
        handleOrder(filter) {
            this.filter = filter;
            if(this.order === 'desc') this.order = 'asc'
            else this.order = 'desc'
            this.getTasks();
        },
        deleteTask(task) {
            axios.get('/sanctum/csrf-cookie').then(resp => {
                axios.delete(`/api/tasks/${task.id}`, task).then(resp => {
                    this.getTasks();
                })
            })
        }
    }
}
</script>
