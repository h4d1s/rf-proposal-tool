import { createApp } from 'vue';
import Discussion from '../../components/Discussion.vue';
import $ from 'jquery';

const btnRequestNewProposal = document.querySelector<HTMLAnchorElement>('.js-btn-request-new-proposal');

if(btnRequestNewProposal) {
    btnRequestNewProposal.addEventListener("click", function(e) {
        e.preventDefault();

        $('#discussionModal').modal('show');
    });
}

$('body').scrollspy({ target: '#proposal-scroll' });

const url = new URL(window.location.href);
if(url.searchParams.has('comment')) {
    if(url.searchParams.get('comment')) {
        $('#discussionModal').modal('show');
    }
}

const vueSelectApp = createApp({
    components: {
        Discussion
    },
    methods: {
        onSend() {
            this.$refs.discussionComponentRef.send();
        }
    }
});
vueSelectApp.component("discussion", Discussion);
vueSelectApp.mount("#proposal-discussion");