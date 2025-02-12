
export default {
  user: {
    data: {},
    token: sessionStorage.getItem("TOKEN"),
  },
  customer: {
    data: []
  },
  adminUsers: {
    data: [],
    links: {},
    page: 1,
    limit: 10,
    from: 0,
    to: 0,
    total: 0,
    loading: false,
  },
  customers: {
    data: [],
    links: {},
    page: 1,
    limit: 10,
    from: 0,
    to: 0,
    total: 0,
    loading: false,
  },
  customerOrders: {
    data: [],
    links: {},
    page: 1,
    limit: 10,
    from: 0,
    to: 0,
    total: 0,
    loading: false,
  },
  orders: {
    data: [],
    links: {},
    page: 1,
    limit: 10,
    from: 0,
    to: 0,
    total: 0,
    loading: false,
  },
  pages: [],
  permissions: {},
  decision: {
    isConfirmed: false,
    isSuccess: false
  }
};
