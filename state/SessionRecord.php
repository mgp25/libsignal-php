<?php
class SessionRecord{
    const ARCHIVED_STATES_MAX_LENGTH = 40;
    protected $previousStates;
    protected $sessionState;
    protected $fresh;

    public function SessionRecord($sessionState = null, $serialized = null){
        /*
        :type sessionState: SessionState
        :type serialized: str
        */
        $this->previousStates = [];
        if($sessionState != null){
            $this->sessionState = $sessionState;
            $this->fresh = false;
        }
        else if($serialized != null){
            $record = new Textsecure_RecordStructure();
            $record->parseFromString($serialized);
            $this->sessionState = new SessionState($record->currentSession);
            $this->fresh = false;
            foreach($record->getPreviousSessions() as $previousStructure)
                $this->previousStates[] = new SessionState($previousStructure);
        }
        else{
            $this->fresh = true;
            $this->sessionState = new SessionState();
        }
    }
    public function hasSessionState($version, $aliceBaseKey){
        if ($this->sessionState.getSessionVersion() == $version && $aliceBaseKey == $this->sessionState->getAliceBaseKey()){
            return true;
        }

        foreach ($this->previousStates as $state){
            if($state->getSessionVersion() == $version && $aliceBaseKey == $state.getAliceBaseKey()){
                return true;
            }
        }

        return false;

    }
    public function getSessionState(){
        return $this->sessionState;
    }

    public function getPreviousSessionStates(){
        return $this->previousStates;
    }

    public function isFresh(){
        return $this->fresh;
    }

    public function archiveCurrentState(){
        $this->promoteState(new SessionState());
    }

    public function promoteState($promotedState){
        array_unshift($this->previousStates, $this->sessionState);
        $this->sessionState = $promotedState;
        if(count($this->previousStates) > self::ARCHIVED_STATES_MAX_LENGTH){
            array_pop($this->previousStates);
        }

    }
    public function setState($sessionState){
        $this->sessionState = $sessionState;
    }

    public function serialize(){
        $previousStructures = [];
        //previousState.getStructure() for previousState in self.previousStates
        foreach($this->previousStates as $previousState){
            $previousStructures[] = $previousState->getStructure();
        }
        $record = new Textsecure_RecordStructure();
        $record->currentSession->MergeFrom($this->sessionState.getStructure());
        $record->setPreviousSessions(array_merge($record->previousStructures,$previousStructures));
        return $record->serializeToString();
    }
}