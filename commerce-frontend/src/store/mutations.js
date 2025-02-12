export function setUser(state, user) {
  state.user.data = user;
}
export function setCustomer(state, customer) {
  state.customer.data = customer;
}

export function setToken(state, token) {
  state.user.token = token;
  if (token) {
    sessionStorage.setItem("TOKEN", token);
  } else {
    sessionStorage.removeItem("TOKEN");
  }
}

export function clearUser(state) {
  state.user.data = null;
}

export function clearToken(state) {
  state.user.token = null;
  sessionStorage.removeItem("TOKEN");
}

export function setAdminUsers(state, [loading, data = null]) {
  if (data) {
    state.adminUsers = {
      ...state.adminUsers,
      data: data.data,
      links: data.meta?.links,
      page: data.meta.current_page,
      limit: data.meta.per_page,
      from: data.meta.from,
      to: data.meta.to,
      total: data.meta.total,
    };
  }
  state.adminUsers.loading = loading;
}

export function setCustomers(state, [loading, data = null]) {
  if (data) {
    state.customers = {
      ...state.customers,
      data: data.data,
      links: data.meta?.links,
      page: data.meta.current_page,
      limit: data.meta.per_page,
      from: data.meta.from,
      to: data.meta.to,
      total: data.meta.total,
    };
  }
  state.customers.loading = loading;
}

export function setCustomerOrders(state, [loading, data = null]) {
  if (data) {
    state.customerOrders = {
      ...state.customerOrders,
      data: data.data,
      links: data.meta?.links,
      page: data.meta.current_page,
      limit: data.meta.per_page,
      from: data.meta.from,
      to: data.meta.to,
      total: data.meta.total,
    };
  }
  state.customerOrders.loading = loading;
}

export function setPages(state, pages) {
  state.pages = pages;
}

export function setUserPermissions(state, {userId, permissions}) {
  state.permissions = {...state.permissions, [userId]: permissions};
}

export function setDecisionConfirm(state, isConfirmed) {
      state.decision.isConfirmed = isConfirmed;
}

export function setDecisionSuccess(state, isSuccess) {
  state.decision.isSuccess = isSuccess
}