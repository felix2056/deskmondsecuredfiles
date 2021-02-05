export default [
  {
    path: '/',
    component: () => import('../layouts/starter.vue'),
    children: [
      // { path: '', name: 'register', component: () => import('../pages/index.vue') },
      // { path: 'login', name: 'login', component: () => import('../pages/login.vue') },
      {
        path: '/teacher/dashboard',
        component: () => import('../layouts/default.vue'),
        children: [
          { path: '', name: 'dashboard', component: () => import('../pages/dashboard.vue') },
          { path: 'my-classes', name: 'my-classes', component: () => import('../pages/myClasses.vue') },
          { path: 'mark-class', name: 'mark-class', component: () => import('../pages/markclass.vue') },
          { path: 'create-class', name: 'create-class', props: true, component: () => import('../pages/createClass.vue') },
          { path: 'liveStream', name: 'live-stream', component: () => import('../pages/livestream.vue') },
          { path: 'liveStreamSchedule', name: 'live-stream-schedule', component: () => import('../pages/liveStreamSchedule.vue') },
        ] 
      }
    ]
  }
]