<template>
    <div class="mb-4 flex justify-between items-center">
        <form @submit.prevent="createNewTask" class="w-full">
            <div class="flex flex-wrap -mx-3 mb-6">
                <!-- Title -->
                <div class=" md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="title">Title</label>
                    <input v-model="formData.title" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-4 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" name="title" type="text" placeholder="Title" value="">
                </div>

                <!-- Priority -->
                <div class="inline-block relative w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="priority">Priority</label>
                    <select v-model="formData.priority" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-4 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" name="assigned_to">
                        <option
                            v-for="(priority, key) in priorities"
                            :key="key"
                            :value="key"
                        >{{ priority }}</option>
                    </select>
                    <div class="pointer-events-none absolute right-0 top-0 flex items-center px-6 mt-10 text-gray-700">
                        <svg class="fill-current h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap -mx-3 mb-6">
                <!-- Assigned To -->
                <div class="inline-block relative w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="assigned_to">Assigned To</label>
                    <select v-model="formData.assigned_to" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-4 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" name="assigned_to">
                        <option :value="currentUser.id">Me</option>
                        <option
                            v-for="(user, key) in users"
                            :key="key"
                            :value="key">{{ user }}</option>
                    </select>
                    <div class="pointer-events-none absolute right-0 top-0 flex items-center px-6 mt-10 text-gray-700">
                        <svg class="fill-current h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>

                <!-- Due Date -->
                <div class="inline-block relative w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="due_date">Due Date</label>
                    <VueTailwindPicker @change="(v) => formData.due_date = v">
                        <input v-model="formData.due_date" class="block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-4 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" type="text"/>
                    </VueTailwindPicker>
                    <div class="pointer-events-none absolute right-0 top-0 flex items-center px-6 mt-10 text-gray-700">
                        <svg class="fill-current h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>
            </div>

            <div class="flex items-center">
                <button class="shadow bg-indigo-500 hover:bg-indigo-700 focus:shadow-outline focus:outline-none uppercase tracking-wide text-white text-xs font-bold py-2 px-4 rounded" type="submit">Save</button>
            </div>

        </form>
    </div>
</template>

<script>
import axios from 'axios'
import VueTailwindPicker from 'vue-tailwind-picker'
export default {
    name: "AddNewTask",
    props: ['currentUser'],
    components: {VueTailwindPicker},
    data() {
        return {
            priorities: ['low', 'medium', 'high', 'critical'],
            users: {},
            formData: {
                title: '',
                created_by: this.currentUser.id,
                assigned_to: this.currentUser.id,
                priority: 0,
                due_date: '',
                errors: []
            }
        }
    },
    methods: {
        createNewTask() {
            axios.get('/sanctum/csrf-cookie', { withCredentials: true }).then(resp => {
                axios.post('/api/tasks', this.formData).then(resp => {
                    localStorage.setItem('current-panel', 'AllMyTasks');
                    location.reload()
                })
            })
        },
        getUsers() {
            axios.get('/sanctum/csrf-cookie', { withCredentials: true }).then(resp => {
                axios.get('/api/users').then(resp => {
                    this.users = resp.data
                })
            })
        }
    },
    created() {
        this.getUsers()
    }
}
</script>
