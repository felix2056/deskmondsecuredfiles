export default [
  {
    path: '/',
    component: () => import('../layouts/starter.vue'),
    children: [
      // { path: '/idesk-student/login', name: '/idesk-student/login', component: () => import('../pages/index.vue') },
      {
        path: '/student/dashboard',
        component: () => import('../layouts/default.vue'),
        children: [
          { path: '', name: 'dashboard', component: () => import('../pages/dashboard.vue') },
          { path: 'browse-classes', name: 'browse-classes', component: () => import('../pages/browseClasses.vue') },
          { path: 'livestream', name: 'livestream', component: () => import('../pages/livestream.vue') },
          { path: 'feedback', name: 'feedback', component: () => import('../pages/feedback.vue') },
          { path: 'my-class', name: 'my-class', component: () => import('../pages/myClass.vue') }
        ]
      }
    ]
  },
]