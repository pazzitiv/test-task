import {Injectable} from '@angular/core';
import {HttpClient, HttpHeaders, HttpParams} from "@angular/common/http";
import {environment} from "src/environments/environment";
import {defaultAuth, StateService} from "../state/state.service";
import {Auth} from "../../interfaces/auth";
import {Observable} from "rxjs";

@Injectable({
  providedIn: 'root'
})
export class ApiService {
  private api: string = environment.api;
  private auth: Auth | undefined;

  constructor(private http: HttpClient, private state: StateService) {
    state.auth.subscribe((auth) => {
      this.auth = auth;
    })
  }

  public get(url: string, params: object = {}, headers: object = {}) {
    if (this.auth?.token) {
      headers = {
        ...headers,
        Authorization: `Bearer ${this.auth.token}`,
      }
    }

    const Headers = new HttpHeaders({
      ...headers
    });

    return this.http.get<Auth>(
      `${this.api}${url}`,
      {
        params: {
          ...params
        },
        headers: Headers,
        withCredentials: true,
      }
    );
  }

  public errorHandler = (error: any) => {
    switch (error.status) {
      case 401:
        this.state.authorize(defaultAuth);
        break;
    }
  }
}
