import { Component, OnInit } from '@angular/core';
import {ApiService} from "../../services/api/api.service";
import {StateService} from "../../services/state/state.service";
import {Router} from "@angular/router";

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {
  public login: string = 'admin';
  public password: string = '123qwe';

  constructor(private Api: ApiService, private state: StateService, private router: Router) { }

  ngOnInit(): void {
  }

  authorize = () => {
    this.Api.get('auth/login', {
      'login': this.login,
      'password': this.password
    })
      .subscribe((res: any) => {
        this.state.authorize(res);
        this.router.navigateByUrl('/');
      }, this.Api.errorHandler)
  }
}
