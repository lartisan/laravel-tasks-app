<template>
    <div class="tasks text-xs">
        <table class="table-auto w-full">
        <thead>
                <tr>
                    <th class="border-b px-4 py-2 text-left">
                        Task
                        <span class="text-gray-500 font-hairline">(Click on a row to complete/uncomplete a task)</span>
                    </th>
                    <th class="border-b px-4 py-2">Priority</th>
                    <th class="border-b px-4 py-2">Assigned To</th>
                    <th class="border-b px-4 py-2">Assigned By</th>
                    <th class="border-b px-4 py-2 text-right">Due Date</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="(task, key) in tasks"
                    :key="key"
                    @click="toggleCompleted(task)"
                    class="hover:bg-gray-200 cursor-pointer"
                >
                    <td :class="{ 'line-through text-gray-400': task.completed }" class="border-b px-4 py-2">{{ task.title }}</td>
                    <td :class="{ 'line-through text-gray-400': task.completed }" class="border-b px-4 py-2 text-center">
                        <span :class="badgeClass(task)" class="text-white text-xs ml-2 px-2 rounded-full">{{ task.priority }}</span>
                    </td>
                    <td :class="{ 'line-through text-gray-400': task.completed }" class="border-b px-4 py-2 text-center">{{ task.assignee === currentUser.name ? 'Me' : task.assignee }}</td>
                    <td :class="{ 'line-through text-gray-400': task.completed }" class="border-b px-4 py-2 text-center">{{ task.owner === currentUser.name ? 'Me' : task.owner }}</td>
                    <td :class="{ 'line-through text-gray-400': task.completed }" class="border-b px-4 py-2 text-right">{{ task.dueDate }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import axios from 'axios'
export default {
    name: "AllTasks",
    props: ['currentUser'],
    data() {
        return {
            tasks: []
        }
    },
    mounted() {
        this.getTasks();
    },
    methods: {
        getTasks() {
            return axios.get('/sanctum/csrf-cookie').then(resp => {
                axios.get('/api/tasks', {withCredentials: true}).then(resp => {
                    this.tasks = resp.data.data
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
        }
    }
}
</script>
