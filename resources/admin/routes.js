import Vaults from './views/Vaults.vue';
import Tools from './views/Tools.vue';
import VaultItemView from './Components/Vaults/VaultModal.vue';
import NotFound from './Components/NotFound.vue';

export var routes = [
    {
        path: '/',
        name: 'vault',
        component: Vaults,
        meta: {
            active_menu: 'vault'
        }
    },
    {
        path: '/vault/item/add', 
        name:'VaultItemAdd', 
        component: VaultItemView
    },
    {
        path: '/vault/item/edit:', 
        name:'VaultItemEdit', 
        component: VaultItemView
    },
    {
        path: '/tools',
        name: 'tools',
        component: Tools,
        meta: {
            active_menu: 'tools'
        }
    },
    { 
        path: '/:pathMatch(.*)*', 
        name: 'NotFound',
        component: NotFound 
    }
    
];

