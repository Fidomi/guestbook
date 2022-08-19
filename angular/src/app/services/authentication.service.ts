import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable, Subject } from 'rxjs';
import { UserType } from "../models/user";
import {TokenStorageService} from "./token-storage.service";

const httpOptions = {
  headers: new HttpHeaders({ 'Content-Type': 'application/json' })
};

@Injectable({
  providedIn: 'root'
})

export class AuthenticationService {
  private isLoggedIn: Subject<boolean> = new Subject<boolean>();
  private currentUser: Subject<UserType> = new Subject<UserType>();

  constructor(private http: HttpClient, private tokenstorage: TokenStorageService) { }

    login = (email:string, password:string ): Observable<any> => {
      return this.http.post<UserType>('backend/login_check', {"username" : email, "password" : password}, httpOptions);
    }

    getCurrentUser = (): Observable<UserType> => {
      let email = this.tokenstorage.getUserName();
      return this.http.get<any>(`backend/api/users/email/${email}`,{
        headers: new HttpHeaders({ 'Content-Type': 'application/json','Authorization':`Bearer ${this.tokenstorage.getToken()}` })
      });
    }

    setUserLoggedIn(isLogged : boolean) {
      this.isLoggedIn.next(isLogged);
    }

    isUserLoggedIn() {
      return this.isLoggedIn.asObservable();
    }

    register(username: string, email: string, password: string): Observable<any> {
      return this.http.post<UserType>('backend/api/login_check',{ email, password });
    }

    setCurrentUser(user: UserType) {
      this.currentUser.next(user);
    }

}
