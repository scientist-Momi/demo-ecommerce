export function isAuthenticated(state) {
  return !!state.user.data;
}

export function getUser(state) {
  return state.user.data;
}

export function getToken(state) {
  return state.user.token;
}


