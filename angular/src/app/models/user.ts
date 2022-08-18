export interface UserType {
  firstname: string;
  lastname: string;
  email: string;
  biography: string;
  picture: string;
  role: string[];
  password: string
}

export class User {
  firstname: string;
  lastname: string;
  email: string;
  biography: string;
  picture: string;
  role: string[];
  password: string

  constructor(user : UserType) {
    this.firstname = user.firstname;
    this.lastname = user.lastname;
    this.email = user.email;
    this.biography = user.biography;
    this.picture = user.picture;
    this.role = user.role;
    this.password = user.password
  }
}
