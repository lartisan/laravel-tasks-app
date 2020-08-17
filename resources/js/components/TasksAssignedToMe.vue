<template>
    <div class="tasks">
        <table class="table-auto w-full">
            <thead class="">
                <tr>
                    <!-- Completed -->
                    <th class="border-b px-4 py-3"></th>

                    <!-- Title -->
                    <th class="border-b px-4 py-3 text-left">
                        <a href="#" @click.prevent="handleOrder('title')" class="flex justify-between items-center focus:border-transparent focus:outline-none">
                            <span>
                                Task
                                <small class="text-xs text-gray-500 font-hairline">(Click on a row to complete/uncomplete a task)</small>
                            </span>
                            <svg class="h-3 fill-current text-gray-600" viewBox="0 0 20 20">
                                <path v-if="filter === 'title' && order === 'asc'" d="M10 19.25L4.5 14H8V1h4v13h3.5L10 19.25z"/>
                                <path v-if="filter === 'title' && order === 'desc'" d="M10 .75L15.5 6H12v13H8V6H4.5L10 .75z"/>
                            </svg>
                        </a>
                    </th>

                    <!-- Created By -->
                    <th class="border-b px-4 py-3">
                        <a href="#" @click.prevent="handleOrder('created_by')" class="flex justify-between items-center focus:border-transparent focus:outline-none">
                            <span>Created By</span>
                            <svg class="h-3 fill-current text-gray-600" viewBox="0 0 20 20">
                                <path v-if="filter === 'created_by' && order === 'asc'" d="M10 19.25L4.5 14H8V1h4v13h3.5L10 19.25z"/>
                                <path v-if="filter === 'created_by' && order === 'desc'" d="M10 .75L15.5 6H12v13H8V6H4.5L10 .75z"/>
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
                    <th class="border-b px-4 py-3 text-right">
                        <a href="#" @click.prevent="handleOrder('due_date')" class="flex justify-between items-center focus:border-transparent focus:outline-none">
                            <span>Due Date</span>
                            <svg class="h-3 fill-current text-gray-600" viewBox="0 0 20 20">
                                <path v-if="filter === 'due_date' && order === 'asc'" d="M10 19.25L4.5 14H8V1h4v13h3.5L10 19.25z"/>
                                <path v-if="filter === 'due_date' && order === 'desc'" d="M10 .75L15.5 6H12v13H8V6H4.5L10 .75z"/>
                            </svg>
                        </a>
                    </th>
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
                    <td :class="{ 'line-through text-gray-400': task.completed }" class="border-b px-4 py-3">{{ task.ownerId === currentUser.id ? 'Me' : task.owner }}</td>
                    <td :class="{ 'line-through text-gray-400': task.completed }" class="border-b px-4 py-3">
                        <span :class="badgeClass(task)" class="text-white text-xs ml-2 px-2 rounded-full">{{ task.priority }}</span>
                    </td>
                    <td :class="{ 'line-through text-gray-400': task.completed }" class="border-b px-4 py-3">{{ task.dueDate }}</td>                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import axios from 'axios'
export default {
    name: "TasksAssignedToMe",
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
                            return task.assigneeId === this.currentUser.id;
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
        }
    }
}
</script>
