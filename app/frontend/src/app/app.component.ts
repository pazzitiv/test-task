import { Component } from '@angular/core';
import {StateService} from "./services/state/state.service";
import {BehaviorSubject} from "rxjs";
import {ActivatedRoute, Router} from "@angular/router";

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent {
  title = 'frontend';
  isAuthorize = new BehaviorSubject(false);

  constructor(protected state: StateService, private route: ActivatedRoute, private Router: Router) {
    this.isAuthorize.subscribe((isAuth) => {
      if(!isAuth && Router.url !== 'auth/login') {
        Router.navigateByUrl('auth/login');
      }
    })

    this.state.auth.subscribe((auth) => {
      this.isAuthorize.next(auth.token !== '');
    })
  }
}
