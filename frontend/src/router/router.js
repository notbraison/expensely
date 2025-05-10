import { createRouter, createWebHistory } from 'vue-router';
import HomePage from '../pages/HomePage.vue';
import UserRegistration from '../pages/UserRegistration.vue';
import Logout from '../pages/Logout.vue';
import UserLogin from '../pages/UserLogin.vue';
import UserList from '../pages/UserList.vue';
import EditUser from '../pages/EditUser.vue';
import About from '../components/About.vue';
import ForgotPassword from '../pages/ForgotPassword.vue';
import UserProfile from '../pages/UserProfile.vue';

import adminList from '../pages/adminList.vue';

import UserHistory from '../components/UserHistory.vue';
import AddComment from '../pages/AddComment.vue';
import PaymentsList from '../components/PaymentsList.vue';
import PaymentDetails from '../components/PaymentDetails.vue';
import CommentsCatalog from '../components/CommentsCatalog.vue';
import Testimonials from '../pages/Testimonials.vue';
import EditComment from '../pages/EditComment.vue';
import FAQ from '../components/FAQ.vue';
import PrivacyPolicy from '../components/PrivacyPolicy.vue';
import ContactUs from '../components/ContactUs.vue';
import Services from '../components/Services.vue';
import CustomerSupport from '../components/CustomerSupport.vue';
import UnderConstruction from '../components/UnderConstruction.vue';
import visualizations from '../components/visualizations.vue';
import Reports from '../components/Reports.vue';
import UserComments from '../components/userComments.vue';
import AdminAddComment from '../pages/AdminAddComment.vue';

//expensely
import Groups from '../pages/Groups.vue';
import GroupForm from '../components/GroupForm.vue';
import AddFriend from '../components/AddFriend.vue'
import Friends from '../components/Friends.vue';
import PaymentIntegration from '../pages/PaymentIntegration.vue';
import Dashboard from '../pages/Dashboard.vue';
import NotificationsPage from '../pages/NotificationsPage.vue';
import AIinsights from '../pages/AIinsights.vue';
import TransactionsPage from '../pages/TransactionsPage.vue';
import PaymentsPage from '../pages/PaymentsPage.vue';
import Calculator from '../components/Calculator.vue';


const routes = [
  {
    path: '/',
    component: HomePage,
    name: 'Home'
  },
  {
    path: "/register",
    component: UserRegistration,
    name: "UserRegistration"
  },
  {
    path: "/logout",
    component: Logout,
    name: "Logout"
  },
  {
    path: "/friend",
    component: Friends,
    name: "Friends"
  },
  {
    path: "/add-friends",
    component: AddFriend,
    name: "AddFriend"
  },
  {
    path: '/groups',
    name: 'groups',
    component: Groups,
  },
  {
    path: '/groups/:groupId/manage-members',
    name: 'manageMembers',
    component: () => import('../components/ManageMembers.vue'), // Lazy load the component
  },
  {
    path: '/payment-integration',
    component: PaymentIntegration,
    name: 'PaymentIntegration',
  },
  
  {
    path: '/dashboard',
    component: Dashboard,
    name: 'dashboard',
  },
  {
    path: '/notifications',
    component: NotificationsPage,
    name: 'Notificatiosn',
  },
  {
    path: '/ai-insights',
    component: AIinsights,
    name: 'AIinsights',
  },
  {
    path: '/transactions',
    component: TransactionsPage,
    name: 'Transactions',
  },
  {
    path: '/payments',
    component: PaymentsPage,
    name: 'payments',
  },
  {
    path: '/calculator',
    component: Calculator,
    name: 'calculator',
  },

  {
    path: '/users',
    component: UserList,
    name: "Userlist"
  },
  {
    path: '/edituser/:id',
    component: EditUser,
    name: "EditUser",
  },
  {
    path: '/login',
    component: UserLogin,
    name: "UserLogin"
  },
  {
    path: '/about',
    name: 'About',
    component: About,
  },
  {
    path: '/contactUs',
    name: 'contactUs',
    component: ContactUs,
  },
  {
    path: '/forgotPassword',
    name: 'forgotPassword',
    component: ForgotPassword
  },
  {
    path: '/profile',
    name: 'userProfile',
    component: UserProfile
  },
  {
    path: '/adminList',
    name: 'adminList',
    component: adminList
  },
  
  {
    path: '/history',
    name: 'UserHistory',
    component: UserHistory,
  },
  {
    path: '/add-comment',
    name: 'AddComment',
    component: AddComment
  },
  {
    path: '/payments-list',
    name: 'PaymentsList',
    component: PaymentsList
  },
  {
    path: '/payment-details/:payment_id',
    name: 'PaymentsDetails',
    component: PaymentDetails
  },
  {
    path: '/comments-catalog',//for admins
    name: 'CommentsCatalog',
    component: CommentsCatalog
  },
  {
    path: '/comments',//for users
    name: 'UserComments',
    component: UserComments
  },
  {
    path: '/testimonials',
    name: 'Testimonials',
    component: Testimonials
  },
  {
    path: '/editComment/:id',
    name: 'EditComment',
    component: EditComment
  },
  {
    path: '/FAQ',
    name: 'FAQ',
    component: FAQ
  },
  {
    path: '/privacy-policy',
    name: 'PrivacyPolicy',
    component: PrivacyPolicy
  },
  {
    path: '/contact-us',
    name: 'ContactUs',
    component: ContactUs
  },
  { path: '/services', 
    name:'services',
    component: Services 
  },
  { path: '/services', 
    name:'services',
    component: Services 
  },
  { path: '/customer-support',
    name:'CustomerSupport',
    component: CustomerSupport 
  },
  { path: '/under-construction',
    name:'UnderConstruction',
    component: UnderConstruction 
  },

  {
    path: '/admin/visualizations',
    name:'visualizations',
    component: visualizations
  },
  {
    path: '/admin/reports',
    name:'reports',
    component: Reports
  },
  {
    path: '/admin/add-comment/:id',//roomid
    name:'addcomment',
    component: AdminAddComment  }
  




];

const router = createRouter({ history: createWebHistory(import.meta.env.BASE_URL), routes });
export default router;