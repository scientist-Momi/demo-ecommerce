import { createRouter, createWebHistory } from 'vue-router'
import AdminLogin from '../views/admin/Login.vue'
import NotFound from "../views/NotFound.vue";
import DashLayout from '../components/admin/DashLayout.vue'
import Dashboard from '../views/admin/Dashboard.vue'
import Product from '../views/admin/product/Product.vue'
import Order from '../views/admin/Order/Order.vue'
import Customer from '@/views/admin/customer/Customer.vue'
import User from '../views/admin/user/User.vue'
import ProductNew from '../views/admin/product/ProductNew.vue';
import ProductAdvanced from '../views/admin/product/ProductAdvanced.vue';
import ProductGeneral from "../views/admin/product/ProductGeneral.vue";
import OrderDetail from '@/views/admin/Order/OrderDetail.vue';
import UserDetail from '@/views/admin/user/UserDetail.vue';
import AdminProfile from '@/views/admin/AdminProfile.vue';
import store from '../store';
import UserProfile from '@/views/admin/user/UserProfile.vue';
// import Role from '@/views/admin/role/Role.vue';
import Page from '@/views/admin/page/Page.vue';
import CustomerDetail from '@/views/admin/customer/CustomerDetail.vue';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      redirect: "/admin/login",
    },
    {
      path: "/admin/app",
      name: "admin-app",
      redirect: "/admin/app/dashboard",
      component: DashLayout,
      meta: {
        requiresAuth: true,
      },
      children: [
        {
          path: "dashboard",
          name: "app.dashboard",
          component: Dashboard,
        },
        {
          path: "product",
          name: "app.product",
          component: Product,
        },
        {
          path: "product/new",
          name: "app.product.new",
          redirect: "product/new/general",
          component: ProductNew,
          children: [
            {
              path: "general",
              name: "app.product.new.general",
              component: ProductGeneral,
            },
            {
              path: "advanced",
              name: "app.product.new.advanced",
              component: ProductAdvanced,
            },
          ],
        },
        {
          path: "order",
          name: "app.order",
          component: Order,
        },
        {
          path: "order/:orderId",
          name: "app.order.detail",
          component: OrderDetail,
        },
        {
          path: "customer",
          name: "app.customer",
          component: Customer,
        },
        {
          path: "customer/:customerId",
          name: "app.customer.detail",
          component: CustomerDetail,
        },
        {
          path: "user",
          name: "app.user",
          component: User,
        },
        {
          path: "user/:userId",
          name: "app.user.detail",
          component: UserDetail,
        },
        {
          path: "user-profile",
          name: "app.user.profile",
          component: UserProfile,
        },
        {
          path: "/admin/profile",
          name: "admin-profile",
          component: AdminProfile,
        },
        {
          path: "page",
          name: "app.page",
          component: Page,
        },
      ],
    },
    {
      path: "/admin/login",
      name: "admin-login",
      component: AdminLogin,
      meta: {
        requiresGuest: true,
      },
    },
    {
      path: "/:pathMatch(.*)",
      name: "notfound",
      component: NotFound,
    },
  ],
});

router.beforeEach((to, from, next) => {
  const isAuthenticated = store.state.user.token;
  if (to.meta.requiresAuth && !isAuthenticated) {
    next({ name: "admin-login" });
  } else if (to.meta.requiresGuest && isAuthenticated) {
    next({ name: "admin-app" });
  } else {
    next();
  }
});

export default router
