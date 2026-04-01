const { createApp, ref, onMounted } = Vue;
createApp({
    setup() {
        const tasks = ref([]);
        const error = ref('');
        const newTask = ref({ title: '', due_date: '', priority: '' });

        const fetchTasks = async () => {
            const res = await fetch('/api/tasks');
            const data = await res.json();
            tasks.value = Array.isArray(data) ? data : [];
        };

        const addTask = async () => {
            error.value = '';
            const res = await fetch('/api/tasks', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify(newTask.value)
            });
            if (res.ok) { newTask.value = { title: '', due_date: '', priority: '' }; fetchTasks(); } 
            else { const errData = await res.json(); error.value = errData.message || 'Error creating task.'; }
        };

        const updateStatus = async (id, status) => {
            await fetch(`/api/tasks/${id}/status`, { method: 'PATCH', headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' }, body: JSON.stringify({ status }) });
            fetchTasks();
        };

        const deleteTask = async (id) => {
            await fetch(`/api/tasks/${id}`, { method: 'DELETE', headers: { 'Accept': 'application/json' }});
            fetchTasks();
        };

        onMounted(fetchTasks);
        return { tasks, newTask, error, addTask, updateStatus, deleteTask };
    }
}).mount('#app');