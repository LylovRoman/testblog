const Editor = {
    name: 'Post Editor',
    date() {
        return {

        }
    },
    mounted() {
        console.log('App mounted!')
    }
}

window.addEventListener('DOMContentLoaded', (event) => {
    Vue.createApp(Editor).mount('#app');
})
