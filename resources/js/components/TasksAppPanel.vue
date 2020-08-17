<template>
    <div class="panel bg-white rounded-lg shadow-lg">
        <!-- Panel Header -->
        <div class="panel-header border-b border-gray-300 px-10 py-6 flex justify-between items-center">
            <h1 class="text-grey-darkest uppercase text-md font-bold">
                {{ currentPanel|titleFromCamel }}
            </h1>

            <!-- Dropdown Menu -->
            <div class="dropdown-menu relative z-10">
                <button @click="isOpen = !isOpen" class="px-4 py-2 text-gray-500 hover:text-gray-700 focus:outline-none focus:border-transparent">
                    <svg class="h-5 fill-current" viewBox="0 0 20 20"><path d="M10.001 7.8a2.2 2.2 0 100 4.402A2.2 2.2 0 0010 7.8zm0-2.6A2.2 2.2 0 109.999.8a2.2 2.2 0 00.002 4.4zm0 9.6a2.2 2.2 0 100 4.402 2.2 2.2 0 000-4.402z"/></svg>
                </button>
                <button v-if="isOpen" @click="isOpen = false" class="fixed w-full h-full inset-0 cursor-default"></button>

                <div v-if="isOpen" class="absolute right-0 text-sm bg-white w-64 py-4 mt-2 rounded-lg shadow-xl">
                    <a
                        v-for="(panel, key) in panels"
                        :key="key"
                        href="#"
                        :class="{ 'bg-indigo-400 text-white': currentPanel === key}"
                        class="block px-6 py-2 my-1 hover:bg-indigo-500 hover:text-white"
                        @click.prevent="currentPanel = key; isOpen = false"
                    >
                        {{ panel }}
                    </a>
                </div>
            </div>
            <!-- End of Dropdown Menu -->
        </div>

        <!-- Panel Body -->
        <div class="panel-body text-sm px-10 py-6">
            <component :is="currentPanel" :currentUser="currentUser"></component>
        </div>

        <!-- Panel Footer -->
        <div class="panel-footer text-gray-500 border-t border-gray-300 text-sm px-10 py-6 flex justify-between items-center">
            <p>All Tasks: 100</p>
            <p>Completed Tasks: 73</p>
            <p>Uncompleted Tasks: 27</p>
        </div>
    </div>
</template>

<script>
import TasksAssignedToMe from "./TasksAssignedToMe";
import TasksCreatedByMe from "./TasksCreatedByMe";
import AddNewTask from "./AddNewTask";
export default {
    name: "TasksAppPanel",
    props: ['currentUser'],
    components: {TasksAssignedToMe, TasksCreatedByMe, AddNewTask},
    data() {
        return {
            isOpen: false,
            currentPanel: 'TasksAssignedToMe',
            panels: {
                TasksAssignedToMe: 'Tasks Assigned To Me',
                TasksCreatedByMe: 'Tasks Created By Me',
                AddNewTask: 'Add New Task'
            }
        }
    },
    watch: {
        currentPanel(panel) {
            localStorage.setItem('current-panel', panel);
        }
    },
    created() {
        if( localStorage.getItem("current-panel") == 'null' )
            this.currentPanel = 'TasksAssignedToMe'
        else
            this.currentPanel = localStorage.getItem("current-panel")
    }
}
</script>
