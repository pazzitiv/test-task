import { Component, OnInit } from '@angular/core';
import {ApiService} from "../../services/api/api.service";
import {defaultAuth, StateService} from "../../services/state/state.service";
import {Router} from "@angular/router";
import {Draw} from "../../interfaces/draw";
import {Prize} from "../../interfaces/prize";

class DrawItem implements Draw{
  constructor(public id: bigint, public name: string, public active: boolean, public prize: Prize | null = null) {
  }
}

@Component({
  selector: 'app-main',
  templateUrl: './main.component.html',
  styleUrls: ['./main.component.scss']
})
export class MainComponent implements OnInit {
  public draws: Draw[] = [];
  public prize: string[] = [];

  constructor(private Api: ApiService, private state: StateService, private router: Router) { }

  ngOnInit(): void {
    this.getDraws()
  }

  draw(id: bigint | string) {
    this.Api.get(`draws/${id}/draw`)
      .subscribe((res: any) => {
        this.getDraws()
      }, this.Api.errorHandler)
  }

  getDraws() {
    this.prize = [];
    this.draws = [];
    this.Api.get('draws')
      .subscribe((res: any) => {

        for(let draw of res)
        {
          let prize = draw.prize;
          let prizeName = ''

          switch (prize?.type) {
            case 'item':
              prizeName = prize?.name;
              break;
            case 'chips':
              prizeName = `${prize?.amount} баллов`;
              break;
            case 'money':
              prizeName = `${prize?.amount} рублей`;
              break;
          }
          this.prize.push(prizeName);
          this.draws.push(new DrawItem(draw.id, draw.name, draw.active, draw.prize ?? null));
        }

      }, this.Api.errorHandler)
  }
}
