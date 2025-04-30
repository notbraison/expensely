import { createRouter, createWebHistory } from 'vue-router';
import HomePage from '../pages/HomePage.vue';
import UserRegistration from '../pages/UserRegistration.vue';
import Logout from '../pages/Logout.vue';
import UserLogin from '../pages/UserLogin.vue';
import UserList from '../pages/UserList.vue';
import Building from '../pages/Building.vue';
import AddBuilding from '../pages/AddBuilding.vue';
import AddFloor from '../pages/AddFloor.vue';
import EditUser from '../pages/EditUser.vue';
import About from '../components/About.vue';
import ForgotPassword from '../pages/ForgotPassword.vue';
import UserProfile from '../pages/UserProfile.vue';
import EditBuilding from '../pages/EditBuilding.vue';
import Floors from '../pages/Floors.vue';
import adminList from '../pages/adminList.vue';
import RoomList from '../pages/RoomList.vue';
import AddRoom from '../components/AddRoom.vue';
import EditRoom from '../components/EditRoom.vue';
import BrowseRooms from '../components/BrowseRooms.vue';
import RoomDetails from '../components/RoomDetails.vue';
import moreInfo from '../components/moreInfo.vue';
import RoomsCatalog from '../components/RoomsCatalog.vue';
import BookingConfirmation from '../pages/BookingConfirmation.vue';
import Payment from '../pages/Payment.vue';
import RentedRooms from '../pages/RentedRooms.vue';
import UserHistory from '../components/UserHistory.vue';
import AddComment from '../pages/AddComment.vue';
import PaymentsList from '../components/PaymentsList.vue';
import PaymentDetails from '../components/PaymentDetails.vue';
import CommentsCatalog from '../components/CommentsCatalog.vue';
import Testimonials from '../pages/Testimonials.vue';
import EditComment from '../pages/EditComment.vue';
import FAQ from '../components/FAQ.vue';
import BookingGuide from '../components/BookingGuide.vue';
import PaymentOptions from '../components/PaymentOptions.vue';
import PrivacyPolicy from '../components/PrivacyPolicy.vue';
import ContactUs from '../components/ContactUs.vue';
import CancellationPolicy from '../components/CancellationPolicy.vue';
import Services from '../components/Services.vue';
import CustomerSupport from '../components/CustomerSupport.vue';
import UnderConstruction from '../components/UnderConstruction.vue';
import BookingsCatalog from '../components/BookingsCatalog.vue';
import visualizations from '../components/visualizations.vue';
import Reports from '../components/Reports.vue';
import UserComments from '../components/userComments.vue';
import AdminAddComment from '../pages/AdminAddComment.vue';

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
    path: "/buildings",
    component: Building,
    name: "Building"
  },
  {
    path: "/addbuilding",
    component: AddBuilding,
    name: "AddBuilding"
  },
  {
    path: '/editbuilding/:id',
    component: EditBuilding,
    name: "EditBuilding",
  },
  {
    path: "/floors/:building_id",
    component: Floors,
    name: "Floor"
  },
  {
    path: "/addfloor/:building_id",
    component: AddFloor,
    name: "AddFloor"
  },
  {
    path: '/floors/:floor_id/rooms',
    component: RoomList,
    name: 'RoomList',
    props: true, // Allow route params to be passed as props
  },
  {
    path: "/addRoom/:floor_id",
    component: AddRoom,
    name: AddRoom
  },
  {
    path: '/editroom/:id',
    component: EditRoom,
    name: "EditRoom",
  },
  {
    path: '/manage-rooms',
    component: RoomsCatalog,
    name: "RoomManagement",
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
    path: '/browserooms',
    name: 'BrowseRooms',
    component: BrowseRooms
  },
  {
    path: '/roominfo/:id', //more info about rooms for users / clients
    name: "roominfo",
    component: RoomDetails
  },
  {
    path: '/moreInfo/:id', //more info about rooms for admins to view
    name: "moreInfo",
    component: moreInfo
  },
  {
    path: '/bookRoom/:room_id',
    name: 'bookingConfirmation',
    component: BookingConfirmation
  },
  {
    path: '/payment/:booking_id/:room_id',
    name: 'Payment',
    component: Payment
  },
  {
    path: '/rented-rooms',
    name: 'RentedRooms',
    component: RentedRooms
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
    path: '/booking-guide',
    name: 'BookingGuide',
    component: BookingGuide
  },
  {
    path: '/payment-options',
    name: 'PaymentOptions',
    component: PaymentOptions
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
  {
    path: '/cancellation-policy',
    name:'CancellationPolicy',
    component: CancellationPolicy
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
    path: '/bookings-catalog',
    name:'BookingCatalog',
    component: BookingsCatalog
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