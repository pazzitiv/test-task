import {Prize} from "./prize";

export interface Draw {
  id: bigint,
  name: string,
  active: boolean,
  prize: Prize | null,
}
