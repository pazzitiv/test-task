import {User} from "./user";

export interface Auth {
  user: User | null,
  token: string,
}
