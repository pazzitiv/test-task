import {Component, OnInit} from '@angular/core';
import {defaultAuth, StateService} from "src/app/services/state/state.service";
import {ApiService} from "src/app/services/api/api.service";
import {User} from "../../interfaces/user";
import {Auth} from "../../interfaces/auth";

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.scss']
})
export class HeaderComponent implements OnInit {
  public user: User | null = defaultAuth.user;

  constructor(private Api: ApiService, private state: StateService) {
    state.auth.subscribe((auth:Auth) => {
      this.user = auth.user;
    })
  }

  ngOnInit(): void {
  }
}
